#include <bits/stdc++.h>
#include <iostream> 

using namespace std;


int main() {
  ios_base::sync_with_stdio(false);
  cin.tie(NULL);

  char s[1000];
  
  for(int i = 0; i < 200; i++){
  	cin.std::istream::getline (s, 100);
  	if(s[0] == NULL) break;
  	int cnt = 0;
    for(int j = 0; j < 1000; j++){
      if(s[j] == ' ') cnt++;
    }

    for(int j = 0; j < 1000; j++){
      if(s[j] == ' ' ){
        cnt--;
        if (cnt == 0){
          s[j] = ',';
        }
      }      
    }


    cout << "ZAGREBAČKA," << s << endl; 
  }

  return 0;
}