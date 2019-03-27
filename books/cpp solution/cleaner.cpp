#include <bits/stdc++.h>
#include <iostream> 

using namespace std;


int main() {
  ios_base::sync_with_stdio(false);
  cin.tie(NULL);

  char s[1000];
  bool knownString[10000];

  //all false
  for(int i = 0; i < 10000; i++){
  	knownString[i] = false;
  }

  
  for(int i = 0; i < 242383; i++){
  	cin.std::istream::getline (s, 1000);
  	if(isdigit(s[0])){
  		
  		//is it alredy known?
  		std::string::size_type sz;   // alias of size_t
  		
  		int i_dec = std::stoi (s,&sz);

  		if(knownString[i_dec]) continue;

  		knownString[i_dec] = true;
  		if(i_dec < 10){
        cout << s << endl;
      }
  	}
  }

  return 0;
}